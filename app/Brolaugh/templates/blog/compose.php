<div class="well well-sm">
    <form class="form-horizonal" action="/<?= $blog->name ?>/compose/send" method="post">
        <fieldset>
            <legend>Compose</legend>
            <div class="form-group">
                <label for="compose-title" class="control-label col-md-2 text-primary">Title</label>
                <div class="col-md-10">
                    <input type="text" id="compose-title" name="compose-title" placeholder="Title"
                           value="<?= (isset($post->title)) ? $post->title : "" ?>" max="255" class="form-control"
                           autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <label type="text" for="compose-url-title" class="control-label col-md-2 text-primary">URL title</label>
                <div class="col-md-10">
                    <input type="text" id="compose-url-title" name="compose-url-title"
                           placeholder="The title that will be shown in the URL"
                           value="<?= (isset($post->url_title)) ? $post->url_title : "" ?>" max="255"
                           class="form-control" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <label for="compose-body" class="control-label col-md-2 text-primary">Body</label>
                <div class="col-md-10">
                    <textarea id="compose-body" name="compose-body" placeholder="Post content" class="form-control"
                              rows="20"
                              autocomplete="off"><?= (isset($post->content)) ? $post->content : "" ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="compose-tags" class="control-label col-md-2 text-primary">Tags</label>
                <div class="col-md-10">
                    <input type="text" id="compose-tags" name="compose-tags"
                           placeholder="Write your tags seperated by comma(,)"
                           value="<?= (isset($post->tags)) ? $post->printTags() : "" ?>" class="form-control"
                           autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <label for="compose-visibility" class="control-label col-md-2 text-primary">Visibility options</label>
                <div class="col-md-10">
                    <select id="compose-visibility" name="compose-visibility" class="form-control">
                        <?php
                        foreach ($post->statusOptions as $option) {
                            echo "\t\t<option value='$option->id'>" . ucfirst($option->name) . "</option>\n";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary btn-raised" value="Submit"/>
                </div>
                <div class="col-md-1">
                    <a href="javascript:previewCompose()" class="btn btn-primary">Preview</a>
                </div>
            </div>
        </fieldset>
    </form>
</div>
