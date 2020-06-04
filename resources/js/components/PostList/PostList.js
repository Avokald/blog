import React, {Component} from 'react';
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";

class PostList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            posts: this.props.posts
        }
    }

    render() {
        return (
            <div>
                { this.state.posts.map((post) => {
                        return (
                            <PostListElement key={post.id}
                                             title={post.title}
                                             link={post.link}
                                             excerpt={post.excerpt}
                                             rating={post.rating}
                                             bookmarks_count={post.bookmarks_count}
                                             comments_count={post.comments_count}
                                             created_at={post.created_at}
                            />
                        )
                    })
                }
            </div>
        );
    }
}

const StyledPostListElement = styled.div`
    border: 1px solid black;
    margin-bottom: 5px;
`;

const PostListElement = (props) => {
    return (
        <StyledPostListElement>
            <div href={props.link}>
                <h2>Title: {props.title}</h2>
                <p>Excerpt: {props.excerpt}</p>
                <p>Created at: {props.created_at}</p>
                <p>Like &#x1f44d;</p>
                <p>Rating: {props.rating}</p>
                <p>Dislike &#128078;</p>
                <p>Bookmark &#128278;</p>
                <p>Bookmarks count: {props.bookmarks_count}</p>
                <p>Comments count: {props.comments_count}</p>
                <Link to={props.link.replace(/^(?:\/\/|[^/]+)*\//, '')}>Go</Link>
            </div>
        </StyledPostListElement>
    )
};

const mapStateToProps = state => {
    console.log(state);
    return {
        posts: state.posts,
    }
};

export default connect(mapStateToProps, null)(PostList);