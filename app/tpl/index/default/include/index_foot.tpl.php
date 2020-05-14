    </div>

    <footer class="container">

    </footer>


    <script type="text/javascript">
    $(document).ready(function(){
        var obj_query_global = $('#search_form_global').baigoQuery();

        $('#search_form_global').submit(function(){
            obj_query_global.formSubmit();
        });
    });
    </script>
