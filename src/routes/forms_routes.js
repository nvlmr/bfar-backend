const express = require("express");
const router = express.Router();

const getForms = require("../controllers/forms/get_forms");
const deleteForm = require("../controllers/forms/delete_form");

router.get("/", getForms);
router.delete("/:id", deleteForm);

module.exports = router;
