const { db, admin } = require("../../config/firebase");
const { v4: uuidv4 } = require("uuid");

module.exports = async (req, res) => {
  try {
    const formId = req.params.id;
    const { answers } = req.body;

    const responseId = uuidv4();

    await db
      .collection("forms")
      .doc(formId)
      .collection("responses")
      .doc(responseId)
      .set({
        answers,
        submitted_at: admin.firestore.FieldValue.serverTimestamp(),
      });

    await db
      .collection("forms")
      .doc(formId)
      .update({
        response_count: admin.firestore.FieldValue.increment(1),
      });

    res.status(201).json({ message: "Response submitted successfully" });

  } catch (error) {
    console.error("Submit Response Error:", error);
    res.status(500).json({ error: "Failed to submit response" });
  }
};
