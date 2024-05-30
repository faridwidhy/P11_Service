document.addEventListener("DOMContentLoaded", function () {
  fetch("http://localhost/P11_service/index1.php")
    .then((response) => response.json())
    .then((data) => {
      const bookList = document.getElementById("books");
      data.forEach((book) => {
        const li = document.createElement("li");
        li.innerHTML = `<strong>${book.judul_buku}</strong> - Jumlah: ${book.jumlah} - Harga: ${book.harga}`;
        bookList.appendChild(li);
      });
    })
    .catch((error) => console.error("Error:", error));
});
