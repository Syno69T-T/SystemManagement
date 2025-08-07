function validateForm() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const course = document.getElementById("course").value.trim();
    const umur = document.getElementById("umur")?.value.trim();
    const kelas = document.getElementById("kelas")?.value.trim();

    if (name === "" || email === "" || course === "") {
        alert("Sila isi semua maklumat wajib (Nama, Email, Kursus).");
        return false;
    }

    // Simple email format check
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Sila masukkan alamat email yang sah.");
        return false;
    }

    // Optional: validate umur if field exists
    if (umur !== undefined) {
        if (umur === "" || isNaN(umur) || umur <= 0 || umur > 120) {
            alert("Sila masukkan umur yang sah.");
            return false;
        }
    }

    // Optional: validate kelas if field exists
    if (kelas !== undefined) {
        if (kelas === "") {
            alert("Sila isi kelas.");
            return false;
        }
    }

    return true;
}