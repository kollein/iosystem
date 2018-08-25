<section id="show-container" class="block-container">
    <div class="search-page-container yt-card">
        <div class="result-search-container">
            <div class="search-header"><p>Lịch sử xem</p></div>
            <div class="search-content">
                <ul id="history-content-from-ajax"></ul>
            </div>

        </div>
    </div>
</section>

<script>
var history_data_json = cache_history.get_cache_history('view_item_history', true);
console.log(history_data_json);
$.post( url_base + '/xhr/_history/', {suggest: history_data_json} ).done(function(data){
    $('#history-content-from-ajax').html(data);
});
</script>