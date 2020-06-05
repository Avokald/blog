import React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import PostList from "./components/PostList";
import PostView from "./components/PostView";
import store from './store/index';
import {BrowserRouter, Link, Route, Switch} from "react-router-dom";

const app = (
    <Provider store={store}>
        <BrowserRouter>
            <div>
                <div>
                    <Link to="/">Home</Link>
                </div>
                <br />
                <Switch>
                    <Route exact path="/" component={PostList} />
                    <Route exact path="/a/:slugged_id" component={PostView} />
                </Switch>
            </div>
            <div style={{ height: "1000px" }}/>
        </BrowserRouter>
    </Provider>
);

ReactDOM.render(app, document.getElementById('app'));