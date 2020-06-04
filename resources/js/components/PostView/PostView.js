import React, {Component} from 'react';
import {connect} from 'react-redux';

class PostView extends Component {
    render() {
        let post = this.props.post;
        return (
            <div>
                <h1>{post.title}</h1>
                <p>{post.excerpt}</p>
                <div>
                    {post.content}
                </div>
                <div>
                    <i>
                    {post.created_at}
                    </i>
                    <br />
                    <b>Rating: {post.rating}</b>
                </div>
            </div>
        );
    }
}

const mapStateToProps = (state, props) => {
    let currentPost = null;

    let sluggedId = props.match.params.slugged_id;
    let postId = sluggedId.split('-')[0];

    for (let post of state.posts) {
        if (Number(post.id) === Number(postId)) {
            currentPost = post;
        }
    }

    console.log(currentPost);
    return {
        post: currentPost,
    }
};

export default connect(mapStateToProps, null)(PostView);