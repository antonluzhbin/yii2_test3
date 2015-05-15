<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
$this->title = 'Книги';
?>
<?php if(Yii::$app->session->hasFlash('BookDeletedError')): ?>
<div class="alert alert-error">
    There was an error deleting your book!
</div>
<?php endif; ?>
 
<?php if(Yii::$app->session->hasFlash('BookDeleted')): ?>
<div class="alert alert-success">
    Your book has successfully been deleted!
</div>
<?php endif; ?>

<?php $author = array_merge(Array(0 => 'автор'), $author); ?>

<?php echo Html::dropDownList('author', ($filter && $filter->author ? $filter->author : 0), $author, array('style' => 'width: 200px; height: 30px;', 'id' => 'author_search')); ?>
<?php echo Html::textInput('name', ($filter && $filter->name ? $filter->name : ''), array('style' => 'width: 200px; margin-left: 30px; height: 30px;', 'placeholder' => 'название книги', 'id' => 'name_search')); ?> 
<br>
Дата выхода книги: 
    <?php echo DatePicker::widget([
        'name'  => 'date1',
        'value'  => ($filter && $filter->date_begin ? $filter->date_begin : ''),
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'id' => 'date1_search',
        'options' => ['style' => 'width: 100px; margin-left: 10px; margin-right: 10px; margin-bottom: 0px;']
        ]); 
    ?> 
до 
    <?php echo DatePicker::widget([
        'name'  => 'date2',
        'value'  => ($filter && $filter->date_end ? $filter->date_end : ''),
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'id' => 'date2_search',
        'options' => ['style' => 'width: 100px; margin-left: 10px; margin-right: 10px; margin-bottom: 0px;']
        ]); 
    ?>
<input type="button" value='Искать' style='float: right' onclick='search();'>
<br><br>
<table class="table table-striped table-hover">
    <tr>
        <td><?php echo showSort('#', 'id', $sort, $order, $filterstr); ?></td>
        <td><?php echo showSort('Название', 'name', $sort, $order, $filterstr); ?></td>
        <td><?php echo showSort('Автор', 'author', $sort, $order, $filterstr); ?></td>
        <td><?php echo showSort('Превью', 'preview', $sort, $order, $filterstr); ?></td>
        <td><?php echo showSort('Дата выхода книги', 'date', $sort, $order, $filterstr); ?></td>
        <td><?php echo showSort('Дата добавления', 'created', $sort, $order, $filterstr); ?></td>
        <td colspan="3">Кнопки действий</td>
    </tr>
    <?php foreach ($data as $book): ?>
        <?php $book = (object)$book; ?>
        <tr>
            <td><?php echo $book->id; ?></td>
            <td><?php echo $book->name; ?></td>
            <td><?php echo $book->author; ?></td>
            <td>
                <?php echo Html::img($book->preview, Array("style" => "width: 50px; height: 50px; cursor:pointer;", 'onclick' => 'showImage(this.src);')); ?>
            </td>
            <td><?php echo $book->date; ?></td>
            <td><?php echo $book->created; ?></td>
            <td>
                <?php echo Html::a(NULL, array('site/updatebook', 'id'=>$book->id, 'filter' => $filterstr, 'sort' => $sort, 'order' => $order), array('class'=>'icon icon-edit')); ?>
            </td>
            <td>
                <a class='icon icon-eye-open' href='javascript:void(0);' onclick='showbook(<?php echo $book->id ?>); return false;'></a>
            </td>
            <td>
                <?php echo Html::a(NULL, array('site/deletebook', 'id'=>$book->id, 'filter' => $filterstr, 'sort' => $sort, 'order' => $order), array('class'=>'icon icon-trash')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="modal fade" id="myModalDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style='border: none; -webkit-box-shadow: none;'></div>
<script>
    function showbook(id){
        $.ajax({
            type:'POST',
            url:'index.php?r=site/showbook&id=' + id,
            success: function(data)
                {
                    $('#myModalDialog').css('background-color', 'rgba(255, 255, 255, 1)');
                    $('#myModalDialog').html(data);
                    $('#myModalDialog').modal();
                    $('.modal-backdrop.fade.in').appendTo('body');
                }
        });
    }
    function showImage(src)
    {
        $('#myModalDialog').html("<img src='" + src + "'>");
        $('#myModalDialog').modal();
        $('.modal-backdrop.fade.in').appendTo('body');
        $('#myModalDialog').css('background-color', 'rgba(255, 255, 255, 0)');
    }
    $('#myModalDialog').click(function () { $('.modal-backdrop.fade.in').click(); });
    
    function search()
    {
        var str = 'index.php?r=site/book&filter=' + $("#author_search").val().toString() + 
            '|' + $("#name_search").val() + '|' + $("#date1_search").val() + '|' + $("#date2_search").val() +
            '<?php echo ($sort ? '&sort=' . $sort : ''); ?>' + '<?php echo ($order ? '&order=' . $order : ''); ?>';
        
        window.location.href = str;
    }
</script>

<?php

function showSort($title, $name, $sort, $order, $filterstr)
{
    if ($name == $sort)
    {
        if ($order == 'asc')
        {
            return Html::a($title, array('site/book', 'sort' => $name, 'order' => 'desc', 'filter' => $filterstr)) . ' '. Html::a(NULL, array('site/book', 'sort' => $name, 'order' => 'desc', 'filter' => $filterstr), array('class'=>'icon icon-arrow-down'));    
        }
        else 
        {
            return Html::a($title, array('site/book', 'sort' => $name, 'order' => 'asc', 'filter' => $filterstr)) . ' '. Html::a(NULL, array('site/book', 'sort' => $name, 'order' => 'asc', 'filter' => $filterstr), array('class'=>'icon icon-arrow-up'));  
        }
    }
    
    return Html::a($title, array('site/book', 'sort' => $name, 'order' => 'asc', 'filter' => $filterstr));
}
?>
