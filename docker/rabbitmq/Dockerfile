FROM rabbitmq:3.8-management
RUN #rabbitmq-plugins enable --offline rabbitmq_mqtt rabbitmq_federation_management rabbitmq_stomp

RUN apt-get update && apt-get install -y curl && apt-get clean

RUN curl -L https://github.com/rabbitmq/rabbitmq-delayed-message-exchange/releases/download/v3.8.0/rabbitmq_delayed_message_exchange-3.8.0.ez -o $RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-3.8.0.ez

RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange
RUN rabbitmq-plugins enable --offline rabbitmq_consistent_hash_exchange
