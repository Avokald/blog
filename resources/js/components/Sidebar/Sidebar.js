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

class Sidebar extends React.Component {
    render() {
        let { categories = [] } = this.props;

        return (
            <StyledSidebar className="active">
                <ul>
                    <li>
                        <Link to={webRouter.route('frontpage')}>Popular</Link>
                    </li>
                    <li>
                        <Link to={webRouter.route('pageNew')}>New</Link>
                    </li>
                    <li>
                        <Link to={webRouter.route('categories')}>Categories</Link>
                    </li>
                    <li>
                        <Link to="/tags">Tags</Link>
                    </li>
                    <li>
                        <Link to="/users">Users</Link>
                    </li>
                    { categories.map((category) => {
                        return (
                            <li key={category.id}>
                                <Link to={absoluteToRelativePath(category.link)}>
                                    {category.title}
                                </Link>
                            </li>
                        );
                    })}
                </ul>
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