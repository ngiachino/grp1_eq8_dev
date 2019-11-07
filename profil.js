function openForm(){
    document.getElementById("newProjectModal").style.display = "block";
}
function closeForm(){
    document.getElementById("newProjectModal").style.display = "none";
}

/*function fillTables(){
    let projectsTable = document.getElementById("projectsList");
    let rows = projectsTable.getElementsByTagName("tr").length;
    while(rows<5){
        let row = document.createElement("tr");
        let cell = document.createElement("td");
        row.appendChild(cell);
        projectsTable.appendChild(row);
        rows++;
    }
}
document.onload = function(){fillTables()};*/

document.getElementById("openNewProjectForm").addEventListener("click", openForm);
document.getElementById("closeForm").addEventListener("click", closeForm);
