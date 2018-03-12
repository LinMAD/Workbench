import _ from 'lodash';
import React from "react";
import ReactDOM from "react-dom";
import {Component} from "react/lib/ReactIsomorphic";
import YTSearch from "youtube-api-search";
import SearchBar from "./Components/search_bar";
import VideoList from "./Components/video_list";
import VideoDetail from "./Components/video_detail";

// Key for Youtube v3 API, restricted by IP
const YT_API_KEY = 'AIzaSyC2zRFqFVwOqJB1Vl2NNpYJ96NirRuL3X4';

// Main app component
class App extends Component {
    constructor(props) {
        super(props);

        this.state = {
            videos: [],
            selectedVideo: null
        };

        this.videoSearch('GOTOconference');
    }

    videoSearch(term) {
        YTSearch({key: YT_API_KEY, term: term}, (videos) => {
            this.setState({
                videos: videos,
                selectedVideo: videos[0]
            });
        });
    }

    render() {
        const videoSearch = _.debounce(
            (term) => { this.videoSearch(term)},
            500
        );

        return (
            <div>
                <div className="row">
                    <SearchBar onSearchTermChange={videoSearch} />
                </div>
                <div className="row">
                    <VideoDetail video={this.state.selectedVideo} />
                    <VideoList
                        onVideoSelect={selectedVideo => this.setState({selectedVideo})}
                        videos={this.state.videos}
                    />
                </div>
            </div>
        );
    }
}

// Render component's HTML and put it to page
ReactDOM.render(
    <App/>,
    document.querySelector('.container')
);
