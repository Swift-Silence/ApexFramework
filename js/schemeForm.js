$(document).ready(function(){

    var $schemeForm = $("form#schemeForm");
    var count = 1;

    $schemeForm.append('<div class="category' + count + '"><span class="catNum">' + count + '</span>: <input type="text" name="cat' + count + 'Name" value="Spending" disabled /><input type="text" name="cat' + count + 'Value" placeholder="Desired Amount" /></div>');
    count++;
    $schemeForm.append('<div class="category' + count + '"><span class="catNum">' + count + '</span>: <input type="text" name="cat' + count + 'Name" value="Savings" disabled /><input type="text" name="cat' + count + 'Value" placeholder="Desired Amount" /></div>');
    count++;

    $("input[name='addCat']").on('click', function(){
        if (count >= 100)
        {
            return false;
        }

        $schemeForm.append('<div class="category' + count + '"><span class="catNum">' + count + '</span>: <input type="text" name="cat' + count + 'Name" placeholder="Category Name" /><input type="text" name="cat' + count + 'Value" placeholder="Desired Amount" /><input type="button" class="tb-erase" value="X" data-tblink="' + count + '" /></div>');

        $("input[data-tblink='" + count + "']").on("click", function(){
            var tbID = $(this).attr('data-tblink');
            $("div.category" + tbID).remove();
            reorderNums();
        });

        count++;
    });

    function reorderNums()
    {
        count = 1;
        $('span.catNum').each(function(){
            $(this).html(count);
            count++;
        });
        $("input[data-tblink='" + count + "']").off("click");
        $("input[data-tblink='" + count + "']").on("click", function(){
            var tbID = $(this).attr('data-tblink');
            $("div.category" + tbID).remove();
            reorderNums();
        });
    }

    $("input[type='submit']").on('click', function(){
        $("input[type='text']").removeAttr('disabled');

        $(this).parent().submit();
    });

});
