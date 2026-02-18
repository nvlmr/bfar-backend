const { db } = require("../../config/firebase");

const getSingleForm = async (req, res) => {
  try {
    const doc = await db.collection("forms").doc(req.params.id).get();

    if (!doc.exists) {
      return res.status(404).json({ error: "Form not found" });
    }

    const form = doc.data();

    // 🔐 Check ownership
    if (form.user_id !== req.user.uid) {
      return res.status(403).json({ error: "Unauthorized" });
    }

    res.json({
      id: doc.id,
      ...form
    });

  } catch (error) {
    console.error("Get Single Form Error:", error);
    res.status(500).json({ error: "Failed to fetch form" });
  }
};

module.exports = getSingleForm;
