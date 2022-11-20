<div>
    <section>

        <div class="message">
            <?php
            if (!empty($params['error'])) {
                switch ($params['error']) {
                    case 'noteNotFound':
                        echo 'Notatka nie została znaleziona!';
                        break;
                    case 'missingNoteId':
                        echo 'Niepoprawny identyfikator notatki';
                        break;
                }
            }
            ?>
        </div>

        <div class="message">
            <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created';
                        echo 'Notatka została utworzona!';
                        break;
                }
            }
            ?>
        </div>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php foreach ($params['notes'] ?? [] as $note) : ?>
                        <td><?php echo (int) $note['id'] ?></td>
                        <td><?php echo htmlentities($note['title']) ?></td>
                        <td><?php echo $note['created'] ?></td>
                        <td><a href="/?action=show&id=<?php echo (int) $note['id'] ?>">Pokaż</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
</div>