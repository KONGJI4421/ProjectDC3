document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const filterDepartment = document.getElementById("filterDepartment");
    const filterStatus = document.getElementById("filterStatus");
    const tableRows = document.querySelectorAll("tbody tr");

    function filterTable() {
        let searchText = searchInput.value.toLowerCase();
        let selectedDepartment = filterDepartment.value.toLowerCase();
        let selectedStatus = filterStatus.value.toLowerCase();

        tableRows.forEach(row => {
            let documentName = row.cells[0].textContent.toLowerCase();
            let department = row.cells[1].textContent.toLowerCase();
            let status = row.cells[6].textContent.toLowerCase(); // สถานะอยู่ที่คอลัมน์ที่ 6

            let matchesSearch = documentName.includes(searchText);
            let matchesDepartment = selectedDepartment === "" || department.includes(selectedDepartment);
            let matchesStatus = selectedStatus === "" || status.includes(selectedStatus);

            if (matchesSearch && matchesDepartment && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchInput.addEventListener("input", filterTable);
    filterDepartment.addEventListener("change", filterTable);
    filterStatus.addEventListener("change", filterTable);
});
