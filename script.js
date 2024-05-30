document.addEventListener("DOMContentLoaded", function () {
  fetch("http://localhost/P11_service/index1.php")
    .then((response) => response.json())
    .then((data) => {
      const bookTable = document.querySelector("#books tbody");
      if (data.status === "gagal") {
        console.error("Error:", data.pesan);
        return;
      }
      data.forEach((book) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                  <td>${book.id}</td>
                  <td>${book.judul_buku}</td>
                  <td>${book.jumlah}</td>
                  <td>${book.harga}</td>
              `;
        bookTable.appendChild(row);
      });
    })
    .catch((error) => console.error("Error:", error));
});
