const { db } = require("../../config/firebase");

module.exports = async (req, res) => {
  try {
    const snapshot = await db.collection("forms").get();

    const forms = snapshot.docs.map(doc => ({
      id: doc.id,
      ...doc.data()
    }));

    res.json(forms);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: "Failed to fetch forms" });
  }
};
