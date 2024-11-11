document.addEventListener("DOMContentLoaded", () => {
    const baseUrl = "http://localhost:8000/api";

    async function fetchPromotionCheck() {
        try {
            const response = await fetch(`${baseUrl}/promotion/check`);
            const data = await response.json();

            document.getElementById("average").textContent = data.average ?? "Keine Daten";
            document.getElementById("bmSubjectsBelow4").textContent = data.bmSubjectsBelow4 ?? "Keine Daten";
            document.getElementById("bmInsufficientGrades").textContent = data.bmInsufficientGrades ?? "Keine Daten";
            document.getElementById("isPromoted").textContent = data.isPromoted ? "Ja" : "Nein";
        } catch (error) {
            console.error("Fehler beim Laden der Promotionsdaten:", error);
        }
    }

    async function fetchPromotionInformatik() {
        try {
            const response = await fetch(`${baseUrl}/promotion/informatik`);
            const data = await response.json();

            document.getElementById("informatik_average").textContent = data.informatik_average ?? "Keine Daten";
            document.getElementById("informatikSubjectsBelow4").textContent = data.informatikSubjectsBelow4 ?? "Keine Daten";
            document.getElementById("insufficientGrades").textContent = data.insufficientGrades ?? "Keine Daten";
            document.getElementById("isInformatikPromoted").textContent = data.isInformatikPromoted ? "Ja" : "Nein";
        } catch (error) {
            console.error("Fehler beim Laden der Informatik-Promotionsdaten:", error);
        }
    }

    

    fetchPromotionCheck();
    fetchPromotionInformatik();
});
