import React from "react";
import {Link} from "react-router-dom";
import {connect} from 'react-redux';
import webRouter from "../../routes/WebRouter";
import {getCategories} from "../../actions";
import styled from 'styled-components';

class Categories extends React.Component {

    componentDidMount() {
        this.props.getCategories();
    }

    render() {
        let { categories = [] } = this.props;
        return (
            <div>
                { categories.map((category) => {
                    return (
                       <CategoryListElement category={category} />
                    );
                })}
            </div>
        );
    }
}

const StyledCategoryListElement = styled.div`
  display: flex;
  flex-direction: row; 
  
  div {
    margin-right: 10px;
  } 
`;

const CategoryListElement = (props) => {
    const category = props.category;
    const categoryLink = webRouter.route('category', [category.slug]);
    return (
        <StyledCategoryListElement key={category.id}>
            <div>
                <Link to={categoryLink}>
                    <img src={category.image}
                         width="40"
                         height="40"
                    />
                </Link>
            </div>
            <div>
                <Link to={categoryLink}>
                    <h2>{category.title}</h2>
                </Link>
                <p>{category.description}</p>
            </div>
        </StyledCategoryListElement>
    );
};


const mapStateToProps = (state) => ({
    categories: state.categories.data,
});

const mapDispatchToProps = (dispatch) => ({
    getCategories: () => dispatch(getCategories()),
});

export default connect(mapStateToProps, mapDispatchToProps)(Categories);