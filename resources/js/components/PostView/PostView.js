import React from 'react';
import {connect} from 'react-redux';
import Comment from "../Comment";
import {getPost} from "../../actions";
import webRouter from "../../routes/WebRouter";
import {Link} from "react-router-dom";

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
                { post.category && (
                <div>
                    <p>Category:
                        <Link to={webRouter.route('category', [post.category.slug])} >
                            {post.category.title}
                        </Link>
                    </p>
                    <p>Category image: {post.category.image}</p>
                </div>
                )}
                { post.author && (
                <div>Author:
                    <Link to={webRouter.route('user', [post.author.id + '-' + post.author.slug])} >
                        {post.author.name}
                    </Link>
                </div>
                )}
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
                    <br />
                    <p>View count: {post.view_count}</p>
                    <p>Comments count: {post.comments_count}</p>
                    <p>Bookmarks count: {post.bookmarks_count}</p>
                </div>

                <hr />
                <h3>Comments</h3>
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