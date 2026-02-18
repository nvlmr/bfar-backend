const { db } = require("../../config/firebase");

const updateForm = async (req, res) => {
  try {
    const docRef = db.collection("forms").doc(req.params.id);
    const doc = await docRef.get();

    if (!doc.exists) {
      return res.status(404).json({ error: "Form not found" });
    }

    const form = doc.data();

    // 🔐 Check ownership
    if (form.user_id !== req.user.uid) {
      return res.status(403).json({ error: "Unauthorized" });
    }

    await docRef.update(req.body);

    res.json({ message: "Form updated successfully" });

  } catch (error) {
    console.error("Update Form Error:", error);
    res.status(500).json({ error: "Failed to update form" });
  }
};

module.exports = updateForm;
