<div class="search-container">
    <form>
        <input data-basePage="{{isset($global->page) ? $global->page : ''}}" type="search" id="quick_search" class="fs-12" data-lijax="300" data-name="q" data-state="both" value="{{request()->q}}">
        <label for="quick_search">
            <i class="fal fa-search"></i>
        </label>
    </form>
</div>
