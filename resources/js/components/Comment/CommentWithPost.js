import React from 'react';
import {Link} from "react-router-dom";
import webRouter from "../../routes/WebRouter";
import Comment from "./Comment";

const commentWithPost = (props) => {
    return (
        <div>
            <p>Post: &nbsp;
                <Link to={webRouter.route('post', [props.comment.post_id + '-' + props.comment.post.slug])}>
                    {props.comment.post.title}
                </Link>
            </p>
            <Comment comment={props.comment}/>
        </div>
    );
};

export default commentWithPost;