import React from "react";
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import {absoluteToRelativePath} from "../../helpers/urlhelper";
import webRouter from "../../routes/WebRouter";

const StyledSidebar = styled.div`
    width: 400px;
    height: 100vh;
`;

const StyledFixedWrapper = styled.div`
    position: fixed;
`;

class Sidebar extends React.Component {
    render() {
        let { categories = [] } = this.props;

        return (
            <StyledSidebar>
                <StyledFixedWrapper>
                    <ul className="list-group">
                        <li className="list-group-item">
                            <Link to={webRouter.route('frontpage')}>Popular</Link>
                        </li>
                        <li className="list-group-item">
                            <Link to={webRouter.route('pageNew')}>New</Link>
                        </li>
                        <li className="list-group-item">
                            <Link to={webRouter.route('categories')}>Categories</Link>
                        </li>
                        <li className="list-group-item">
                            <Link to={webRouter.route('tags')}>Tags</Link>
                        </li>
                        <li className="list-group-item">
                            <Link to="/users">Users</Link>
                        </li>

                    </ul>
                    <h5>Cats:</h5>
                    <ul className="list-group">
                        { categories.map((category) => {
                            return (
                                <li key={category.id} className="list-group-item">
                                    <Link to={absoluteToRelativePath(category.link)}>
                                        {category.title}
                                    </Link>
                                </li>
                            );
                        })}
                    </ul>
                </StyledFixedWrapper>
            </StyledSidebar>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        categories: state.categories.data,
    };
};

export default connect(mapStateToProps, null)(Sidebar);