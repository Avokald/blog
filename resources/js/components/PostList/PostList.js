import React, {Component} from 'react';
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import webRouter from "../../routes/WebRouter";

class PostList extends Component {
    render() {
        return (
            <div>
                { this.props.posts && this.props.posts.map((post) => {
                        return (
                            <PostListElement key={post.id}
                                             post={post}
                            />
                        )
                    })
                }
            </div>
        );
    }
}

const StyledPostListElement = styled.div`
    margin-bottom: 25px;
`;

const PostListElement = (props) => {
    let post = props.post;
    return (
        <StyledPostListElement className="card">
            <div className="category card-header">
                Category:&nbsp;
                <Link to={webRouter.route('category', [post.category.slug])}>
                    {post.category.title}
                </Link>
                &nbsp; | &nbsp;
                {/*<img src={post.author.image}*/}
                {/*alt={post.author.name}*/}
                {/*width="50"*/}
                {/*height="50"*/}
                {/*/>*/}
                Author: &nbsp;
                <Link to={webRouter.route('user', [post.author.id + '-' + post.author.slug])}>{post.author.name}</Link>
                &nbsp; | &nbsp; Created at: {post.created_at}
            </div>
            <div href={post.link} className="card-body">
                <h2>Title: {post.title}</h2>
                <p>Excerpt: {post.excerpt}</p>
                <p>Like &#x1f44d;</p>
                <p>Rating: {post.rating || '-'}</p>
                <p>Dislike &#128078;</p>
                <p>Bookmark &#128278;</p>
                <p>Bookmarks count: {post.bookmarks_count}</p>
                <p>Comments count: {post.comments_count}</p>
                <p>TODO Options: hide | report | ignore author | ignore category</p>
                <Link to={webRouter.route('post', [post.id + '-' + post.slug])}>Go</Link>
            </div>
        </StyledPostListElement>
    )
};

const mapStateToProps = (state, props) => {
    if (!props.posts) {
        return {
            posts: state.posts,
        }
    } else {
        return {};
    }
};

export default connect(mapStateToProps, null)(PostList);