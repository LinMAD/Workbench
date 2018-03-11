import React from "react";
import ReactDOM from "react-dom";
import {Component} from "react/lib/ReactIsomorphic";
import YTSearch from "youtube-api-search";
import SearchBar from "./Components/search_bar";

// Key for Youtube v3 API, restricted by IP
const YT_API_KEY = 'AIzaSyC2zRFqFVwOqJB1Vl2NNpYJ96NirRuL3X4';

// Main app component
class App extends Component {
    constructor(props) {
        super(props);

        this.state = { videos: [] };

        YTSearch({key: YT_API_KEY, term: 'surfboards'}, (videos) => {
            this.setState({ videos });
        });
    }

    render() {
        return (
            <div>
                <SearchBar/>
            </div>
        );
    }
}

// Render component's HTML and put it to page
ReactDOM.render(
    <App/>,
    document.querySelector('.container')
);
