Данный проект - это небольшое вебприложение по управлению Приказами организации.
Стек: YII2, php, JS, HTML, CSS, git.

В проекте использовался подход к проектированию - SOLID


Тезисы:
1) Приказ может совершить над другим приказом только ОДНО действие - или отменить или изменить
2) Приказ может изменить несколько приказов, если раннее приказ не изменял модифицируемый приказ
3) Приказ может отменить несколько приказов, если раннее эти приказы не были отменены этим приказом или другими приказами
4) При удалении приказа - удаляются записи в которых указано какие приказы он удалил или изменил, далее вычисляется новый статус приказа - на основании оставшихся записей

5) Пользователь может отправить приказ в себе в "Избранное", такие приказы отображаются на отдельной странице 
6) Система авторизации сделана с использованием RBAC и интеграции с AD
7) Система логирования - вынесена в отдельный модуль
8) Статусы приказа:
      действующий,
      изменен,
      отменен
      
      searchModel
      
      
      
      
      CREATE TABLE division 
      (
        id INTEGER PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        short_name VARCHAR(200) NOT NULL,
        is_old BOOL,
        color VARCHAR(20) NOT NULL,
        created_at INTEGER NOT NULL,
        created_by INTEGER NOT NULL,
        updated_at INTEGER NOT NULL,
        updated_by INTEGER NOT NULL
      ) 
      
      CREATE SEQUENCE public.division_id_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;
      
      ALTER SEQUENCE public.division_id_seq OWNED BY public.division.id;
      
      ALTER TABLE ONLY public.division ALTER COLUMN id SET DEFAULT nextval('public.division_id_seq'::regclass);
      
      
      
      
      
       CREATE TABLE prikaz_division 
            (
              id SERIAL INTEGER PRIMARY KEY,
              prikaz_id INTEGER NOT NULL,
              division_id INTEGER NOT NULL,
              FOREIGN KEY (prikaz_id) REFERENCES prikaz(id)
              FOREIGN KEY (division_id) REFERENCES division(id)
            ) 
      