
document.addEventListener('DOMContentLoaded', function () {
    const timeline = document.querySelector('.timeline');
    const progressLine = document.querySelector('.timeline-progress');
    const items = document.querySelectorAll('.timeline ul li');

    function updateTimeline() {
        const timelineRect = timeline.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const scrollMiddle = window.scrollY + windowHeight / 1.5;

        const start = timeline.offsetTop;
        const end = start + timeline.offsetHeight;

        let progress = scrollMiddle - start;
        progress = Math.max(0, Math.min(progress, timeline.offsetHeight));

        progressLine.style.height = progress + 'px';

        items.forEach(item => {
            const itemTop = item.offsetTop + timeline.offsetTop;
            if (scrollMiddle >= itemTop) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    window.addEventListener('scroll', updateTimeline);
    window.addEventListener('resize', updateTimeline);
    updateTimeline();
});
