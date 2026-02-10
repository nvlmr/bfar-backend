const { admin, db } = require("../../config/firebase");
const transporter = require("../../utils/mailer.util");
const crypto = require("crypto");

module.exports = async (req, res) => {
  const { first_name, middle_name, last_name, email, password } = req.body;

  try {
    // Validation
    if (!first_name || !last_name || !email || !password) {
      return res.status(400).json({
        error: "First name, last name, email, and password are required",
      });
    }

    // Create Firebase Auth user
    const user = await admin.auth().createUser({
      email,
      password,
    });

    // Generate tokens
    const verification_link = crypto.randomBytes(32).toString("hex");
    const api_key = crypto.randomBytes(32).toString("hex");
    const csrf_token = crypto.randomBytes(32).toString("hex");

    const userData = {
      user_id: user.uid,
      first_name,
      middle_name: middle_name || null,
      last_name,
      email,
      api_key,
      csrf_token,
      status: "verifying",
      verification_link,
      verification_expires_at: Date.now() + 24 * 60 * 60 * 1000,
      reset_password_token: null,
      created_at: admin.firestore.FieldValue.serverTimestamp(),
      updated_at: admin.firestore.FieldValue.serverTimestamp(),
    };

    await db.collection("users").doc(user.uid).set(userData);

    const verifyLink = `${process.env.FRONTEND_VERIFY_URL}?token=${verification_link}`;

    await transporter.sendMail({
      from: `"BFAR Support" <${process.env.EMAIL_USER}>`,
      to: email,
      subject: "Verify Your Account",
      html: `
        <h2>Welcome to BFAR</h2>
        <p>Please verify your account:</p>
        <a href="${verifyLink}">${verifyLink}</a>
        <p>This link expires in 24 hours.</p>
      `,
    });

    return res.status(201).json({
      message: "Registration successful. Verification email sent.",
    });

  } catch (error) {
    console.error(error);

    // Cleanup created auth user if error occurs
    if (email) {
      const existingUser = await admin
        .auth()
        .getUserByEmail(email)
        .catch(() => null);

      if (existingUser) {
        await admin.auth().deleteUser(existingUser.uid);
      }
    }

    return res.status(400).json({
      error: error.message || "Registration failed",
    });
  }
};
