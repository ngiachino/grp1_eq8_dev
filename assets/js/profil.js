function openForm(){
    document.getElementById("newProjectModal").style.display = "block";
}
function closeForm(){
    document.getElementById("newProjectModal").style.display = "none";
}

document.getElementById("openNewProjectForm").addEventListener("click", openForm);
document.getElementById("closeForm").addEventListener("click", closeForm);
