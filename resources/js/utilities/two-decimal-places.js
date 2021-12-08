const twoDecimalPlaces = function(val) {
    return (Math.round(val * 100) / 100.0).toFixed(2);
};

export default twoDecimalPlaces;
