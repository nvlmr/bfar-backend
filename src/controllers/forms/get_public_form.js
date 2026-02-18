const { db } = require("../../config/firebase");

const getPublicForm = async (req, res) => {
  try {
    const doc = await db.collection("forms").doc(req.params.id).get();

    if (!doc.exists) {
      return res.status(404).json({ error: "Form not found" });
    }

    res.json({
      id: doc.id,
      ...doc.data()
    });

  } catch (error) {
    console.error("Public Form Error:", error);
    res.status(500).json({ error: "Failed to fetch public form" });
  }
};

module.exports = getPublicForm;
