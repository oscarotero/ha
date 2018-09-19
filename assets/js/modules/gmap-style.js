const c = {
    base: '#e8e4d3',
    builds: '#ddd9c3',
    nature: '#c7ddc3',
    water: '#c9d9d9',
    roads: '#f4f3ed',
    text: '#00334d',
    text2: '#a0986d'
};

export default [
    {
        elementType: 'geometry',
        stylers: [
            {
                color: c.base
            }
        ]
    },
    {
        elementType: 'labels.icon',
        stylers: [
            {
                visibility: 'off'
            }
        ]
    },
    {
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    },
    {
        elementType: 'labels.text.stroke',
        stylers: [
            {
                visibility: 'off'
            }
        ]
    },
    {
        featureType: 'administrative.land_parcel',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    },
    {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [
            {
                color: c.nature
            }
        ]
    },
    {
        featureType: 'poi',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    },
    {
        featureType: 'poi.park',
        elementType: 'geometry',
        stylers: [
            {
                color: c.nature
            }
        ]
    },
    {
        featureType: 'poi.park',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    },
    {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [
            {
                color: c.roads
            }
        ]
    },
    {
        featureType: 'road.arterial',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text2
            }
        ]
    },
    {
        featureType: 'road.highway',
        elementType: 'geometry',
        stylers: [
            {
                color: c.roads
            }
        ]
    },
    {
        featureType: 'road.highway',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    },
    {
        featureType: 'road.local',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text2
            }
        ]
    },
    {
        featureType: 'transit.line',
        elementType: 'geometry',
        stylers: [
            {
                color: c.builds
            }
        ]
    },
    {
        featureType: 'transit.station',
        elementType: 'geometry',
        stylers: [
            {
                color: c.builds
            }
        ]
    },
    {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [
            {
                color: c.water
            }
        ]
    },
    {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: c.text
            }
        ]
    }
];
