#SmartFlanders Summarizer
This repo contains a summarizer for Smart Flanders data (https://github.com/oSoc17/smartflanders-backend).
It is a separate server that queries this data and saves statistical aggregations (mean, min, max, q75, q25, median) for different time intervals
(1h, 3h, 12h, 1 day, 3 days) and publishes it. This data can be used to perform studies or build applications on long-term data without having to
perform immense amounts of queries.
