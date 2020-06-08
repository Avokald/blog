import React from 'react';
import {connect} from 'react-redux';
import {getUserProfile} from "../../../actions";
import {NavLink, Route, Switch} from "react-router-dom";
import PostList from "../../PostList/PostList";
import webRouter from "../../../routes/WebRouter";

class UserProfile extends React.Component {
    constructor(props) {
        super(props);

        let { params } = this.props.match;
        this.defaultLink = webRouter.route('user', [params.sluggedId]);
    }

    componentDidMount() {
       this.props.getUserProfile(this.props.match.params.sluggedId.split('-')[0]);
    }

    componentDidUpdate(prevProps) {
        const id = this.props.match.params.sluggedId.split('-')[0];
        const previousId = prevProps.match.params.sluggedId.split('-')[0];
        if (previousId !== id) {
            this.props.getUserProfile(id);
        }
    }

    render() {
        const defaultLink = this.defaultLink;
        const user = this.props.profile;
        return (
            <div>User Profile
                <p>Banner: {user.banner}</p>
                <p>Image: {user.image}</p>
                <h1>Name: {user.name}</h1>
                <p>Description: {user.description}</p>
                <p>Created: {user.created_at}</p>

                <ul className="nav">
                    <li className="nav-item">
                        <NavLink to={`${defaultLink}`}
                                 className="nav-link"
                                 activeClassName="active">
                            Posts
                        </NavLink>
                    </li>

                    <li className="nav-item">
                       <NavLink to={`${defaultLink}` + "/comments"}
                                 className="nav-link"
                                 activeClassName="active">
                           Comments
                       </NavLink>
                    </li>

                    <li className="nav-item">
                        <NavLink to={defaultLink + "/drafts"}
                                 className="nav-link"
                                 activeClassName="active">
                            Drafts
                        </NavLink>
                    </li>

                    <li className="nav-item">
                        <NavLink to={defaultLink + "/bookmarks"}
                                 className="nav-link"
                                 activeClassName="active">
                            Bookmarks posts
                        </NavLink>
                    </li>

                    <li className="nav-item">
                        <NavLink to={defaultLink + "/bookmarks/comments"}
                                 className="nav-link"
                                 activeClassName="active">
                            Bookmarks comments
                        </NavLink>
                    </li>
                </ul>

                <Switch>
                    {/* Must be in this specific order otherwise some will be unreachable */}
                    <Route exact path={this.props.match.path + "/bookmarks/comments"} render={() => (<h3>Bookmarks comments</h3>)} />
                    <Route exact path={this.props.match.path + "/bookmarks"} render={() => (<h3>Bookmarks posts</h3>)} />
                    <Route exact path={this.props.match.path + "/comments"} render={() => (<h3>Comments</h3>)} />
                    <Route exact path={this.props.match.path + "/drafts"} render={() => (<h3>Drafts</h3>)} />
                    <Route exact path={this.props.match.path} render={() => {
                        if (this.props.posts) {
                            return (
                                <React.Fragment>
                                    <h3>Posts</h3>
                                    <PostList posts={this.props.posts}/>
                                </React.Fragment>
                            );
                        }
                    }}/>

                </Switch>
            </div>

        );
    }
}

const mapStateToProps = (state) => {
   return {
       profile: state.user.data,
       loading: state.user.loading,
       posts: state.user.data.posts,
   };
};

const mapDispatchToProps = (dispatch) => ({
    fetchUserProfile: (userId) => dispatch(fetchUserProfile(userId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(UserProfile);