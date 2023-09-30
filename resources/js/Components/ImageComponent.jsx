import React from 'react';

export default function ImageComponent ({ imagePath, width, heigth, className ="" }) {
    const divStyle = {
        backgroundImage: `url('/storage/${imagePath}')`,
        backgroundSize: 'cover',
        width: '200px',
        height: '200px',
        borderRadius: 100
    };

    return (
        <div style={divStyle} className={className}>
            {/* Остальное содержимое компонента */}
        </div>
    );
};

