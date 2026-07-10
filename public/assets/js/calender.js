class AvailabilityCalendar {

    constructor(options = {}) {

        this.leftGrid = document.getElementById("calendarGrid1");
        this.rightGrid = document.getElementById("calendarGrid2");

        this.leftTitle = document.getElementById("calendarTitle1");
        this.rightTitle = document.getElementById("calendarTitle2");

        this.currentDate = new Date();

        this.month = this.currentDate.getMonth();
        this.year = this.currentDate.getFullYear();
        this.initialMonth = this.currentDate.getMonth();
        this.initialYear = this.currentDate.getFullYear();

        // Booking ranges
        this.bookedDates = options.bookedDates || [];

        this.init();
    }

    init() {

        this.render();

        document.getElementById("prevMonth").addEventListener("click", () => {

            this.previousMonth();

        });

        document.getElementById("nextMonth").addEventListener("click", () => {

            this.nextMonth();

        });
        document.getElementById("todayBtn").addEventListener("click", () => {

            this.goToToday();

        });

    }

    render() {

        this.renderMonth(
            this.month,
            this.year,
            this.leftGrid,
            this.leftTitle
        );

        let next = new Date(this.year, this.month + 1);

        this.renderMonth(
            next.getMonth(),
            next.getFullYear(),
            this.rightGrid,
            this.rightTitle
        );

        this.togglePrevButton();

    }

    togglePrevButton() {

        const btn = document.getElementById("prevMonth");

        if (
            this.month === this.initialMonth &&
            this.year === this.initialYear
        ) {

            btn.disabled = true;
            btn.classList.add("disabled");

        } else {

            btn.disabled = false;
            btn.classList.remove("disabled");

        }

    }

    renderMonth(month, year, grid, title) {

        grid.innerHTML = "";

        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        title.innerHTML = months[month] + " " + year;

        const firstDay = new Date(year, month, 1);

        let startDay = firstDay.getDay();

        startDay = startDay === 0 ? 6 : startDay - 1;

        const totalDays = new Date(year, month + 1, 0).getDate();

        // Empty cells
        for (let i = 0; i < startDay; i++) {

            const cell = document.createElement("div");
            cell.className = "day empty";

            grid.appendChild(cell);

        }

        // Days
        for (let day = 1; day <= totalDays; day++) {

            const date = new Date(year, month, day);

            const cell = document.createElement("div");

            cell.classList.add("day");

            cell.innerHTML = day;

            if (this.isToday(date)) {
                cell.classList.add("today");
            }

            if (this.isBooked(date)) {

                cell.classList.add("booked");
                cell.title = "Booked";

                if (this.isToday(date)) {
                    cell.classList.add("today");
                }

            } else {

                cell.classList.add("available");
                // cell.title = "Not Available";

                if (this.isToday(date)) {
                    cell.classList.add("today");
                }

            }

            grid.appendChild(cell);

        }

    }
    previousMonth() {

        this.month--;

        if (this.month < 0) {

            this.month = 11;

            this.year--;

        }

        this.render();

    }

    nextMonth() {

        this.month++;

        if (this.month > 11) {

            this.month = 0;

            this.year++;

        }

        this.render();

    }
    goToToday() {

        this.month = this.initialMonth;

        this.year = this.initialYear;

        this.render();

    }
    isBooked(date) {

        const current = this.formatDate(date);

        return this.bookedDates.includes(current);

    }
    isToday(date) {

        const today = new Date();

        return (
            date.getDate() === today.getDate() &&
            date.getMonth() === today.getMonth() &&
            date.getFullYear() === today.getFullYear()
        );

    }
    formatDate(date) {

        const y = date.getFullYear();

        const m = String(date.getMonth() + 1).padStart(2, "0");

        const d = String(date.getDate()).padStart(2, "0");

        return `${y}-${m}-${d}`;

    }

}
