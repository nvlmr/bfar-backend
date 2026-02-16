require("dotenv").config();
const express = require("express");
const cors = require("cors");

const authRoutes = require("./src/routes/auth_routes");
const { admin, db } = require("./src/config/firebase");

const app = express();

app.use(cors({
  origin: "http://localhost:5173",
  methods: ["GET", "POST", "PUT", "DELETE"],
  credentials: true
}));

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.use("/api/auth", authRoutes);

app.get("/test", async (req, res) => {
  const snapshot = await db.collection("users").limit(1).get();
  res.json(snapshot.docs.map(d => d.data()));
});

app.listen(5000, () => {
  console.log("Server running on http://localhost:5000");
});

