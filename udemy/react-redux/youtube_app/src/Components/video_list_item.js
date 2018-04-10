import React from "react";

const VideoListItem = ({video, onVideoSelect}) => {
    const imgUrl = video.snippet.thumbnails.default.url;

    return (
        <li onClick={() => onVideoSelect(video)} className="list-group-item">
            <div className="video-list media">
                <div className="media-left">
                    <img className="media-object rounded" src={imgUrl} />
                </div>
                <div className="media-body">
                    <h6 className="media-heading video-title">{video.snippet.title}</h6>
                </div>
            </div>
        </li>
    );
};

export default VideoListItem;
