<div>
    <section class="mb-5">
        <div class="bg-light">
            <div class="card-body">
                <div class="d-flex gap-4">
                    <form  class="col-md-10 mb-4">
                        <textarea wire:model="commentText" class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea>
                    </form>
                   <span class="col-md-2"><button wire:click.prevent="saveComment" class="btn btn-sm btn-primary">Save Comment</button></span> 
                </div>
            </div>
        </div>
    </section>
</div>