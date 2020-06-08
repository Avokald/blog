import React from 'react';
import {connect} from 'react-redux';
import Comment from "../Comment";
import {getPost} from "../../actions";

class PostView extends React.Component {

    componentDidMount() {
        const id = this.props.match.params.sluggedId.split('-')[0];
        this.props.getPost(id);
        window.scrollTo(0,0);
    }

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

                <div>
                    { post.comments && post.comments.map((comment) => {
                        return (
                           <Comment key={comment.id} comment={comment} />
                        );
                    })}
                </div>
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        post: state.post.data,
    }
};

const mapDispatchToProps = (dispatch) => ({
    getPost: (postId) => dispatch(getPost(postId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(PostView);