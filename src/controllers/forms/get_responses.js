const admin = require("firebase-admin");
const db = admin.firestore();

const getResponses = async (req, res) => {
  try {
    const { id } = req.params;

    const snapshot = await db
      .collection("forms")
      .doc(id)
      .collection("responses")
      .get(); // ❌ removed orderBy

    console.log("Form ID:", id);
    console.log("Docs found:", snapshot.size);

    const responses = snapshot.docs.map((doc) => ({
      id: doc.id,
      ...doc.data(),
    }));

    res.json(responses);
  } catch (error) {
    console.error("Error fetching responses:", error);
    res.status(500).json({ message: "Failed to fetch responses" });
  }
};

module.exports = getResponses;
