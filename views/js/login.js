$('.showLoginTable').DataTable({
    "ajax": "ajax/loginrequest.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [[0, "desc"], [3, "desc"]]
});
