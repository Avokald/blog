

class CommentTree {
    constructor(post) {
        this.post = post.id;
        this.leafs = [];

        for (let comment of post.comments) {
            if (comment.reply_id === null) {
                this.leafs.push(comment);

            }
        }

    }
}

export default CommentTree;