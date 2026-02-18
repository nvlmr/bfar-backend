const { db, admin } = require("../../config/firebase");

const createForm = async (req, res) => {
  try {
    const { title, description, questions } = req.body;

    if (!title || !questions || questions.length === 0) {
      return res.status(400).json({ error: "Title and questions are required" });
    }

    const formData = {
      title,
      description: description || "",
      questions,
      user_id: req.user.uid, // 🔥 attach owner
      created_at: admin.firestore.FieldValue.serverTimestamp(),
      response_count: 0
    };

    const docRef = await db.collection("forms").add(formData);

    res.status(201).json({
      id: docRef.id,
      ...formData
    });

  } catch (error) {
    console.error("Create Form Error:", error);
    res.status(500).json({ error: "Failed to create form" });
  }
};

module.exports = createForm;
