import React from "react";
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import {absoluteToRelativePath} from "../../helpers/urlhelper";

const StyledSidebar = styled.div`
    width: 400px;
    height: 100vh;
`;

class Sidebar extends React.Component {
    render() {
        let categories = this.props.categories;
        return (
            <StyledSidebar className="active">
                <ul>
                    <Link to="/new">New</Link>
                    <Link to="/categories">Categories</Link>
                    { categories.map((category) => {
                        return (
                            <li>
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
        categories: state.categories,
    };
};

export default connect(mapStateToProps, null)(Sidebar);