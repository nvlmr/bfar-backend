const { admin, db } = require("../../config/firebase");

module.exports = async (req, res) => {
  const { token } = req.query;

  try {
    if (!token) {
      return res.status(400).json({ error: "Invalid verification token" });
    }

    const usersRef = db.collection("users");
    const snapshot = await usersRef
      .where("verification_link", "==", token)
      .limit(1)
      .get();

    if (snapshot.empty) {
      return res.status(400).json({ error: "Invalid or expired token" });
    }

    const doc = snapshot.docs[0];
    const user = doc.data();

    if (user.status === "active") {
      return res.status(200).json({ message: "Account already verified" });
    }

    if (Date.now() > user.verification_expires_at) {
      return res.status(400).json({ error: "Verification link expired" });
    }

    await usersRef.doc(doc.id).update({
      status: "active",
      verification_link: null,
      verification_expires_at: null,
      updated_at: admin.firestore.FieldValue.serverTimestamp(),
    });

    return res.json({
      message: "Account successfully verified",
    });

  } catch (error) {
    console.error(error);
    return res.status(500).json({
      error: "Verification failed",
    });
  }
};
