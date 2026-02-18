const { db } = require("../../config/firebase");

module.exports = async (req, res) => {
  try {
    const formId = req.params.id;
    const formRef = db.collection("forms").doc(formId);

    // 🔥 Get all responses
    const responsesSnapshot = await formRef.collection("responses").get();

    // 🔥 Delete each response
    const batch = db.batch();

    responsesSnapshot.forEach((doc) => {
      batch.delete(doc.ref);
    });

    await batch.commit();

    // 🔥 Now delete the form itself
    await formRef.delete();

    res.json({ message: "Form and responses deleted successfully" });

  } catch (error) {
    console.error("Delete Form Error:", error);
    res.status(500).json({ error: "Failed to delete form" });
  }
};
