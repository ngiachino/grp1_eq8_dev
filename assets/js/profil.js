function openForm(){
    document.getElementById("newProjectModal").style.display = "block";
}
function closeForm(){
    document.getElementById("newProjectModal").style.display = "none";
}
function openProject(project){
    let projectTitle=project.getElementsByClassName("projectTitle")[0].textContent;
    let projectOwner=project.getElementsByClassName("projectOwner")[0].textContent;
    window.location.href = "./projet.php?title="+projectTitle+"&owner="+projectOwner;
}

document.getElementById("openNewProjectForm").addEventListener("click", openForm);
document.getElementById("closeForm").addEventListener("click", closeForm);
let projects = document.getElementsByClassName("tdProject");
for(let i = 0; i<projects.length;i++){
    let project = projects[i];
    project.addEventListener("click",function(){openProject(project);});
}
