const express = require("express");
const router = express.Router();

const auth = require("../middleware/auth_middleware"); // 🔥 ADD THIS

const getAnalytics = require("../controllers/analytics/get_analytics");
const getForms = require("../controllers/forms/get_forms");
const getSingleForm = require("../controllers/forms/get_single_form");
const getPublicForm = require("../controllers/forms/get_public_form");
const createForm = require("../controllers/forms/create_form");
const updateForm = require("../controllers/forms/update_form");
const deleteForm = require("../controllers/forms/delete_form");
const submitResponse = require("../controllers/forms/submit_response");
const getResponses = require("../controllers/forms/get_responses");


// =========================
// PUBLIC ROUTES
// =========================
router.get("/public/:id", getPublicForm);
router.post("/public/:id/responses", submitResponse);


// =========================
// PROTECTED ROUTES (ADMIN)
// =========================
router.get("/analytics/:id", auth, getAnalytics);

router.get("/", auth, getForms);
router.post("/", auth, createForm);

router.get("/:id", auth, getSingleForm);
router.get("/:id/responses", auth, getResponses);
router.put("/:id", auth, updateForm);
router.delete("/:id", auth, deleteForm);

module.exports = router;
