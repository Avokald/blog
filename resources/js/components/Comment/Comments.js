import React from 'react';
import Comment from "./Comment";

const comments = (props) => {
    return (
        <React.Fragment>
            { props.comments && props.comments.map((comment) => (
                <Comment key={comment.id} comment={comment} />
            ))
            }
        </React.Fragment>
    );
};

export default comments;