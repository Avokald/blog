import React from 'react';
import webRouter from "../../routes/WebRouter";
import {Link} from "react-router-dom";

class Comment extends React.Component {
    render() {
        const comment = this.props.comment;
        return (
            <div id={'comment_' + comment.id} className="media">
                <img className="d-flex mr-3"
                     src={comment.author.image}
                     alt={comment.author.name}
                     width="64"
                     height="64"
                />
                <div className="media-body">
                    <p>Author:
                        <Link to={webRouter.route('user', [comment.author.id + '-' + comment.author.slug])}>
                            {comment.author.name}
                        </Link>
                    </p>
                    <p>Created at: {comment.created_at}</p>
                    <p>Id: {comment.id}</p>
                    {(comment.reply_id) && (
                        <p><a href={'#comment_' + comment.reply_id}>Reply to {comment.reply_id}</a></p>)
                    }
                    <p>Content: {comment.content}</p>
                    <hr />
                </div>
            </div>
        );
    }
}

export default Comment;