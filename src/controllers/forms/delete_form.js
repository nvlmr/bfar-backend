const { db } = require("../../config/firebase");

module.exports = async (req, res) => {
  try {
    await db.collection("forms").doc(req.params.id).delete();
    res.json({ message: "Form deleted successfully" });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: "Failed to delete form" });
  }
};
