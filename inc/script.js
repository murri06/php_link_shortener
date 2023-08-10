$(document).ready(function () {
    $('.copy-button').click(function () {
        // Find the previous <a> element and its content
        const linkContent = $(this).prev('a').text();
        const tooltip = $(this).find('div');

        // Copy the link content to the clipboard
        navigator.clipboard.writeText(linkContent);

        // Change icon class to show copied state
        const icon = $(this).find('i');
        icon.removeClass('bi-clipboard-fill');
        icon.addClass('bi-clipboard-check-fill');
        tooltip.css('opacity', '1');

        // Reset icon class after a short delay
        setTimeout(function () {
            icon.removeClass('bi-clipboard-check-fill');
            icon.addClass('bi-clipboard-fill');
            tooltip.css('opacity', '0');
        }, 2000); // Change back after 2 seconds
    });
    $('.close-button').click(function () {
        $('.popup-box').fadeOut();
        $.ajax("inc/copyLink.php");
    })

});