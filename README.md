Это тестовый проект, на его основе изучаю RBAC - yii2 изучал 2 года назад, неделю назад начал вспоминать изученное

создал AdminController для управления RBAC: пользователями, ролями и разрешениями. 
Также там добавил функционал работы с телефонами пользователями:
модель для базы - Phone
модель для формы - UserCreateForm
Потраченное время - 3ч

Для решения первой задачки создал BalanceController
модель для формы - BalanceForm
Потраченное время - 1ч

Использую PostgreSQl:
код создания таблицы phone:
CREATE TABLE Phone
(
    id SERIAL PRIMARY KEY,
    userId INTEGER,
    phone VARCHAR(20)  NOT NULL,
	created_at INTEGER, 
	updated_at INTEGER,
    Quantity INTEGER,
     FOREIGN KEY (userId) REFERENCES "user" (id) ON DELETE CASCADE
);

Залить на GIT - ушло 20 мин
