<div class="container">
    <a href="/question" class="btn btn-info"><i class="fa fa-plus"></i> all question </a>


    <form method="post" action="/question/add">
        // TIME DIFFICULTY ANSWER DESCREPTION CHAPTER_ID TYPE_ID
        <div class="form-group">
            <label for="DESCREPTION">question </label>
            <textarea name="DESCREPTION" class="form-control" id="DESCREPTION" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="ANSWER">question </label>
            <textarea name="ANSWER" class="form-control" id="ANSWER" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label for="TIME"> TIME </label>
            <input type="number" class="form-control" step="0.5" min="1" id="TIME" placeholder="1.5">
        </div>

        <div class="form-group">
            <label for="DIFFICULTY"> DIFFICULTY </label>
            <input type="number" class="form-control" step="0.5" name="DIFFICULTY" min="1" id="DIFFICULTY"
                   placeholder="1.5">
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>


        <input type="submit" name="submit" value="submit">
    </form>


</div>