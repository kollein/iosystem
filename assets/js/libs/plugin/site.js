// SHOW LOADER
function make_loader_icon_html(size, stroke_width){
    size = size ? size : '100%';
    stroke_width = stroke_width ? stroke_width : 6;
    // INIT HTML
    var loader_str_html  = '<div class="loader" style="width:' + size + '">';
        loader_str_html += '<svg class="circular" viewBox="25 25 50 50">';
        loader_str_html += '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="' + stroke_width + '" stroke-miterlimit="10"/>';
        loader_str_html += '</svg>';
        loader_str_html += '</div>';
    return loader_str_html;
}