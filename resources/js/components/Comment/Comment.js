import React from 'react';

class Comment extends React.Component {
    render() {
        const comment = this.props.comment;
        return (
            <div id={'comment_' + comment.id}>
                { (comment.reply_id) && (<p><a href={'#comment_' + comment.reply_id}>Reply to {comment.reply_id}</a></p>)}
                <p>Id: {comment.id}</p>
                <p>Name: {comment.author.name}</p>
                <p>Content: {comment.content}</p>
                <p>Created at: {comment.created_at}</p>
            </div>
        );
    }
}

export default Comment;