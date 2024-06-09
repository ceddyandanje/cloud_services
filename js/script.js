function displayTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    document.getElementById('current_time').innerHTML = hours + ':' + minutes + ':' + seconds;
    setTimeout(displayTime, 1000);
}

document.addEventListener('DOMContentLoaded', function () {
    displayTime();

    // Update cost based on selected service type
    document.getElementById('service_type').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var cost = selectedOption.getAttribute('data-cost');
        document.getElementById('cost').value = cost;
    });
});
