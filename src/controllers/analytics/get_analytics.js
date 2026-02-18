const { db } = require("../../config/firebase");

module.exports = async (req, res) => {
  try {
    const { id } = req.params;

    // 1️⃣ Get form
    const formRef = db.collection("forms").doc(id);
    const formDoc = await formRef.get();

    if (!formDoc.exists) {
      return res.status(404).json({ error: "Form not found" });
    }

    const form = formDoc.data();

    // 2️⃣ Get responses from SUBCOLLECTION
    const snapshot = await formRef.collection("responses").get();

    const responses = snapshot.docs.map(doc => doc.data());

    // 3️⃣ Build analytics per question
    const questionsAnalytics = form.questions.map((question) => {

      const allAnswers = responses.flatMap(response =>
        (response.answers || [])
          .filter(a => a.question_id === question.id)
          .map(a => a.answer)
      );

      // Multiple choice / dropdown / checkboxes
      if (["multiple_choice", "dropdown", "checkboxes"].includes(question.type)) {

        const counts = {};

        allAnswers.forEach(answer => {
          if (Array.isArray(answer)) {
            answer.forEach(opt => {
              counts[opt] = (counts[opt] || 0) + 1;
            });
          } else {
            counts[answer] = (counts[answer] || 0) + 1;
          }
        });

        return {
          question_id: question.id,
          title: question.title,
          type: question.type,
          responses: Object.entries(counts).map(([option, count]) => ({
            option,
            count
          }))
        };
      }

      // Rating
      if (question.type === "rating") {
        return {
          question_id: question.id,
          title: question.title,
          type: question.type,
          responses: allAnswers.map(Number)
        };
      }

      // Text answers
      return {
        question_id: question.id,
        title: question.title,
        type: question.type,
        responses: allAnswers
      };
    });

    res.json({
      total_responses: responses.length,
      questions: questionsAnalytics
    });

  } catch (error) {
    console.error("Analytics Error:", error);
    res.status(500).json({ error: "Failed to generate analytics" });
  }
};
